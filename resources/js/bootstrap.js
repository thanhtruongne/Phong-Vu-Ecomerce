import axios from 'axios';
import ClientPath from "./Routes/RoutePaths/ClientPath";

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.$ = window.jQuery = jQuery;

const notification = () => {
    Modal.warning({
        content: "Vui lòng đăng nhập lại",
        onOk: () => {
            window.location.href = "/login";
        },
        okText: 'Ok',
        className: "popupSession",
    });
};

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

axios.interceptors.response.use(
    function (response) {
        hasNotified = false;
        return response;
    },
    function (error) {
        switch (error.response.status) {
            case 419:
                {
                    if (!hasNotified) {
                        hasNotified = true;
                        notification();
                    }
                }
                break;
            case 403:
                {
                    window.location.href = `/403`;
                }
                break;
            case 401: {
                window.location.href = "/login";
            }
                break;
            case 404:
                {
                    window.location.href = `/${ClientPath.NOTFOUND}`;
                }
                break;

        }
        return Promise.reject(error);
    }
);
