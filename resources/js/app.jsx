import { createBrowserRouter, Navigate, RouterProvider } from "react-router-dom";
import ClientProvider from "./Contexts/ClientContext";
import LayoutClient from "./Layouts/LayoutClient";
import ClientRoute from "./Routes/Route/ClientRoute";
import ClientPath from "./Routes/RoutePaths/ClientPath";
function App() {
    const router = createBrowserRouter([
        {
            path: '/',
            element: <Navigate to={ClientPath.HOME} />
        },
        {
            element: (
                <ClientProvider>
                    <LayoutClient />
                </ClientProvider>
            ),
            children: ClientRoute
        },
    ]);

    return <RouterProvider router={router} />;
}

export default App;
