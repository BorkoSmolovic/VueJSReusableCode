/**
 * Vue Router
 *
 * @library
 *
 * https://router.vuejs.org/en/
 */

// Lib imports
import Vue from 'vue'
import Router from 'vue-router'

import Login from '@/pages/auth/Login.vue'
// Routes
import Dashboard from "../views/Dashboard";
import UserProfile from "../views/UserProfile";
import TableList from "../views/TableList";
import Typography from "../views/Typography";
import Icons from "../views/Icons";
import Maps from "../views/Maps";
import Notifications from "../views/Notifications";
import Users from "../pages/users/Users";
import Partners from "../pages/partners/Partners";
import ServiceCategoryTreeView from "../components/service_categories/ServiceCategoryTreeView";
import Countries from "../pages/countries/Countries";
import Cities from "../pages/cities/Cities";
import ContactType from "../pages/ContactType/ContactType";
import PartnerType from "../pages/partnerTypes/PartnerType";
import Bank from "../pages/banks/Bank";
import Vat from "../pages/vats/Vat";
import Workers from "../pages/workers/Workers";
import WorkerTypes from "../pages/workerTypes/WorkerTypes";
import Items from "../pages/items/items";
import Evidention from "../pages/evidention/Evidention";
import Reports from "../pages/Excel/Reports";
import Vehicles from "../pages/vehicles/Vehicles";
import PartnerEvidentions from "../pages/partnerEvidentions/PartnerEvidentions";
import PartnerContracts from "../pages/partnerContracts/PartnerContracts";
import EvidentionWorkspace from "../pages/workspace/EvidentionWorkspace";
import Services from "../pages/services/Services";
import ReportsPartner from "../pages/Excel/ReportsPartner";
import TabelarniSelekt from "../pages/components/TabelarniSelekt";
import TabelarnoUpravljanje from "../pages/components/TabelarnoUpravljanje";
import DialogZaDodavanje from "../pages/components/DialogZaDodavanje";
import DialogZaIzmjenu from "../pages/components/DialogZaIzmjenu";
import DialogZaDetalje from "../pages/components/DialogZaDetalje";

Vue.use(Router)

function routes() {
  let routes = []
  /* if (isNaN(localStorage.getItem('partner_id'))) {
     routes = [
       {path: '*', name: 'dash', redirect: '/dashboard', meta: {forAuth: true}},
       {path: '/login', name: 'Login', component: Login, meta: {forVisitors: true}},
       {path: '/', name: 'Dashboard', component: Dashboard, meta: {forAuth: true}},
       {path: '/user-profile', name: 'Korisnik', component: UserProfile, meta: {forAuth: true}},
       /!* {path: '/statuses', name: 'Statuses', component: Statuses, meta: {forAuth: true}},*!/
       {path: '/partner-evidentions', name: 'Evidencije partner', component: PartnerEvidentions, meta: {forAuth: true}},
       {path: '/table-list', name: 'Table List', component: TableList, meta: {forAuth: true}},
       {path: '/typography', name: 'Typography', component: Typography, meta: {forAuth: true}},
       {path: '/icons', name: 'Icons', component: Icons, meta: {forAuth: true}},
       {path: '/maps', name: 'Maps', component: Maps, meta: {forAuth: true}},
       {path: '/items', name: 'Items', component: Items, meta: {forAuth: true}},
       {path: '/notifications', name: 'Notifications', component: Notifications, meta: {forAuth: true}},
       {path: '/users', name: 'Korisnici', component: Users, meta: {forAuth: true}},
       {path: '/partners', name: 'Partneri', component: Partners, meta: {forAuth: true}},
       {path: '/services', name: 'Usluge', component: ServiceCategoryTreeView, meta: {forAuth: true}},
       {path: '/countries', name: 'Drzave', component: Countries, meta: {forAuth: true}},
       {path: '/cities', name: 'Gradovi', component: Cities, meta: {forAuth: true}},
       {path: '/contactTypes', name: 'Tipovi kontakata', component: ContactType, meta: {forAuth: true}},
       {path: '/partnerType', name: 'Tipovi partnera', component: PartnerType, meta: {forAuth: true}},
       {path: '/bank', name: 'Banke', component: Bank, meta: {forAuth: true}},
       {path: '/vat', name: 'PDV', component: Vat, meta: {forAuth: true}},
       {path: '/evidention', name: 'Evidencije', component: Evidention, meta: {forAuth: true}},
       {path: '/vehicles', name: 'Vozila', component: Vehicles, meta: {forAuth: true}},
       /!*    {path: '/contract', name: 'Ugovori', component: Contract, meta: {forAuth: true}},*!/
       /!* {path: '/warehouse', name: 'Magacini', component: Warehouse, meta: {forAuth: true}},*!/
       {path: '/worker', name: 'Radnici', component: Workers, meta: {forAuth: true}},
       {path: '/workerTypes', name: 'Tipovi Radnika', component: WorkerTypes, meta: {forAuth: true}},
       {path: '/excel', name: 'Excel', component: Excel, meta: {forAuth: true}},
     ]
   } else {
     routes = [
       {path: '/contracts', name: 'Ugovori', component: PartnerContracts, meta: {forAuth: true}},
       {path: '/login', name: 'Login', component: Login, meta: {forVisitors: true}},
       {path: '/', name: 'Dashboard', component: Dashboard, meta: {forAuth: true}},
       {path: '/user-profile', name: 'Korisnik', component: UserProfile, meta: {forAuth: true}},
       {path: '/partner-evidentions', name: 'Evidencije partnera', component: PartnerEvidentions, meta: {forAuth: true}},
     ]
   }*/
  routes = [
    {path: '*', name: 'dash', redirect: '/dashboard', meta: {forAuth: true}},
    {path: '/login', name: 'Login', component: Login, meta: {forVisitors: true}},
    {path: '/', name: 'Dashboard', component: Dashboard, meta: {forAuth: true}},
    /* {path: '/statuses', name: 'Statuses', component: Statuses, meta: {forAuth: true}},*/
    {path: '/partner-evidentions', name: 'Evidencije partner', component: PartnerEvidentions, meta: {forAuth: true}},
    {path: '/table-list', name: 'Table List', component: TableList, meta: {forAuth: true}},
    {path: '/typography', name: 'Typography', component: Typography, meta: {forAuth: true}},
    {path: '/icons', name: 'Icons', component: Icons, meta: {forAuth: true}},
    {path: '/maps', name: 'Maps', component: Maps, meta: {forAuth: true}},
    {path: '/items', name: 'Items', component: Items, meta: {forAuth: true}},
    {path: '/notifications', name: 'Notifications', component: Notifications, meta: {forAuth: true}},
    {path: '/users', name: 'Korisnici', component: Users, meta: {forAuth: true}},
    {path: '/partners', name: 'Partneri', component: Partners, meta: {forAuth: true}},
    {path: '/services', name: 'Usluge', component: ServiceCategoryTreeView, meta: {forAuth: true}},
    {path: '/countries', name: 'Drzave', component: Countries, meta: {forAuth: true}},
    {path: '/cities', name: 'Gradovi', component: Cities, meta: {forAuth: true}},
    {path: '/contactTypes', name: 'Tipovi kontakata', component: ContactType, meta: {forAuth: true}},
    {path: '/partnerType', name: 'Tipovi partnera', component: PartnerType, meta: {forAuth: true}},
    {path: '/bank', name: 'Banke', component: Bank, meta: {forAuth: true}},
    {path: '/vat', name: 'PDV', component: Vat, meta: {forAuth: true}},
    {path: '/evidention', name: 'Radna zona', component: Evidention, meta: {forAuth: true}},
    {path: '/vehicles', name: 'Vozila', component: Vehicles, meta: {forAuth: true}},
    /*    {path: '/contract', name: 'Ugovori', component: Contract, meta: {forAuth: true}},*/
    /* {path: '/warehouse', name: 'Magacini', component: Warehouse, meta: {forAuth: true}},*/
    {path: '/worker', name: 'Radnici', component: Workers, meta: {forAuth: true}},
    {path: '/workerTypes', name: 'Tipovi Radnika', component: WorkerTypes, meta: {forAuth: true}},
    {path: '/reports', name: 'Izvještaji', component: Reports, meta: {forAuth: true}},
    {path: '/reportsPartner', name: 'Izvještaji', component: ReportsPartner, meta: {forAuth: true}},
    {path: '/contracts', name: 'Ugovori', component: PartnerContracts, meta: {forAuth: true}},
    {path: '/user-profile', name: 'Korisnik', component: UserProfile, meta: {forAuth: true}},
    {path: '/partner-evidentions', name: 'Evidencije partnera', component: PartnerEvidentions, meta: {forAuth: true}},
    {path: '/evidentions', name: 'Evidencije', component: EvidentionWorkspace, meta: {forAuth: true}},
    {path: '/serviceTypes', name: 'Tipovi usluga', component: Services, meta: {forAuth: true}},
    {path: '/dialog-choose-item', name: 'Tabelarni selekt', component: TabelarniSelekt, meta: {forAuth: true}},
    {path: '/table-management', name: 'Tabelarno upravljanje', component: TabelarnoUpravljanje, meta: {forAuth: true}},
    {path: '/add-component', name: 'Dialog za dodavanje', component: DialogZaDodavanje, meta: {forAuth: true}},
    {path: '/edit-component', name: 'Dialog za izmjenu', component: DialogZaIzmjenu, meta: {forAuth: true}},
    {path: '/details-component', name: 'Dialog za detalje', component: DialogZaDetalje, meta: {forAuth: true}},
  ]
  return routes
}

export default new Router({
  mode: 'history',
  routes: routes()
});

// Vue.use(Meta)
//
// // Bootstrap Analytics
// // Set in .env
// // https://github.com/MatteoGabriele/vue-analytics
// if (process.env.GOOGLE_ANALYTICS) {
//     Vue.use(VueAnalytics, {
//         id: process.env.GOOGLE_ANALYTICS,
//         router,
//         autoTracking: {
//             page: process.env.NODE_ENV != 'development'
//         }
//     })
// }

// export default router
