import App from "@/app.jsx";
import ReactDOM from 'react-dom';
import { Provider } from "react-redux";
import { PersistGate } from "redux-persist/integration/react";
import '../css/app.css'; // Import Tailwind CSS
import '../sass/app.scss';
import './bootstrap';
import { persiststore, store } from "./store";


ReactDOM.render(
    <Provider store={store}>
        <PersistGate loading={null} persistor={persiststore}>
            <App />
        </PersistGate>
    </Provider>,
    document.getElementById('root')
);
    