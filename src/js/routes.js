import Dashboard from './pages/Dashboard';
import CardManager from './pages/CardManager';
import CptManager from './pages/CptManager';
import TaxManager from './pages/TaxManager';
// import AddCard from './components/AddCard';
import Support from './Components/Supports';


export const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/card_manager',
        name: 'card_manager',
        component: CardManager
    },
    {
        path: '/cpt_manager',
        name: 'cpt_manager',
        component: CptManager
    },
    {
        path: '/taxonomy_manager',
        name: 'taxonomy_manager',
        component: TaxManager
    },
    {
        path: '/support',
        name: 'supports',
        component: Support
    }
];
