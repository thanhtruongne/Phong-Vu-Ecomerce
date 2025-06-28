import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import ReactDOM from "react-dom/client";
import '../sass/app.scss';
import App from "./App";
import ClientProvider from "./contexts/ClientProvider";
import './index.css';

const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnWindowFocus: false,
            refetchOnMount: false,
            refetchOnReconnect: false,
            retry: 0
        }
    }
});

ReactDOM.createRoot(document.getElementById("root") as HTMLElement).render(
    <QueryClientProvider client={queryClient}>
        <ClientProvider>
            <App />
        </ClientProvider>
    </QueryClientProvider>
);

