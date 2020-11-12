import Dashboard from './pages/Dashboard';
import CardManager from './pages/CardManager';
import AddNewCard from './pages/AddNewCard';
import CptManager from './pages/CptManager';
import TaxManager from './pages/TaxManager';
import EditGrid from './pages/EditGrid';
// import AddCard from './components/AddCard';
import Support from './Components/Supports';
import CardList from "./components/card/CardList";

const test = { template: '<div>foo</div>' }; // inline template
export const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/card_manager',
        name: 'card_manager',
        component: CardManager,
        children :[
            {
                path: 'new_card/:type',
                name: 'new_card',
                component: AddNewCard,
                props:true
            },
            {
                path: 'card_list',
                name: 'card_list',
                component: CardList,
            },
            {
                path: 'card_edit/:id',
                name: 'card_edit',
                component: EditGrid
            }
        ]
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
