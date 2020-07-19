import axios from 'axios';

export function login (credentials) {
    return new Promise(function(resolve, reject) {
      axios.post('api/login', credentials).then((response) => {
        resolve(response.data);
      }).catch((error) => {
        reject("Wrong username or password");
      })
    });
}

export function getLocalUser(){
  const user = localStorage.getItem('user');
  if(!user){
    return null;
  }
  return JSON.parse(user);
}
