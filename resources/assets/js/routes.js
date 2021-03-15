import Home from './components/Home';
import Evaluations from './components/Evaluations';
import Games from './components/Games';
import Profile from './components/Profile';
import NotFound from './components/NotFound';

export default {
    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/evaluations',
            component: Evaluations
        },
        {
            path: '/games',
            component: Games
        },
        {
            path: '/profile',
            component: Profile
        }
    ]
}
