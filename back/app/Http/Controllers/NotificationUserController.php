<?php

namespace App\Http\Controllers;

use App\Evidention;
use App\Notification;
use App\NotificationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Matrix\Exception;

class NotificationUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function leaveEvidentionSeen(){
//        try{
//
//        }catch (Exception $e)
//        $notifications = Notification::where('user_id', Auth::id())->get();
//        foreach ($notifications as $notification){
//            NotificationUser::add(Auth::id(), $notification->id);
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationUser $notificationUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationUser $notificationUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationUser $notificationUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationUser  $notificationUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationUser $notificationUser)
    {
        //
    }
}
