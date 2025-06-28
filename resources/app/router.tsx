import { createBrowserRouter } from 'react-router-dom';
import LayoutHorizon from './components/layouts/LayoutHorizon';
import ClientRoute from './Routes/Route/ClientRoute';

const router = createBrowserRouter([
    {
        element: <LayoutHorizon />,
        children: ClientRoute
    },
]);

export default router;
