import ClientPath from "@/Routes/RoutePath/ClientPath.jsx";
import { Modal } from 'antd';
import axios from 'axios';


let instance = axios.create({ withCredentials: true })


const notification = () => {
    Modal.warning({
        content: 'Phiên đăng nhập hết hạn. Vui lòng đăng nhập lại',
        onOk: () => {
            window.location.href = '/login';
        },
        okText: 'Ok',
        className: 'popupSession',
    });
};

instance.interceptors.request.use(
    (config) => {
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            config.headers['X-CSRF-TOKEN'] = token.content;
        } else {
            console.warn('CSRF token not found. Ensure <meta name="csrf-token"> is present.');
        }
        return config;
    },
    (error) => Promise.reject(error)
);

let countRetry = 0

instance.interceptors.response.use(
    (response) => {
        countRetry = 0
        return response.data
    },
    async (error) => {
        const status = error.response?.status;
        if (status === 419 && countRetry < 1) {
            countRetry++;
            try {
                const response = await axios.get('/refresh-csrf', { withCredentials: true });
                handleSetSession(response);
                return instance(error.config);
            } catch (retryError) {
                countRetry = 0;
                notification();
                return Promise.reject(retryError.response?.data || retryError);
            }
        } else if (status === 401) {
            window.location.href = '/login';
        } else if (status === 403) {
            window.location.href = '/403';
        } else if (status === 404) {
            window.location.href = `/${ClientPath.NOTFOUND}`;
        }
        countRetry = 0;
        return Promise.reject(error.response?.data || error);
    }
);


function handleSetSession(response) {
    let meta = document.head.querySelector('meta[name="csrf-token"]');
    if (meta) {
        meta.content = response.data.csrf_token;
    } else {
        meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = response.data.csrf_token;
        document.head.appendChild(meta);
    }
}

export default instance;
