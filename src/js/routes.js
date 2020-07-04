import Dashboard from './pages/Dashboard';
import CardManager from './pages/CardManager';
import AddNewCard from './pages/AddNewCard';
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
        path: '/new_card',
        name: 'new_card',
        component: AddNewCard
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
