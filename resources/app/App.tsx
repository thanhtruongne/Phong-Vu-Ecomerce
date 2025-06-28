import { ReactQueryDevtools } from '@tanstack/react-query-devtools';
import { RouterProvider } from 'react-router-dom';
import router from "./router";

function App() {
    return (
        <div className="block relative">
            <RouterProvider router={router} />
            <ReactQueryDevtools initialIsOpen={true} />
        </div>
    );
}

export default App;
