import { clearAcessToken, getAccessToken, getRefreshToken, saveAccessToken } from '@/utils/cookies';
import axios, { AxiosError, AxiosResponse, InternalAxiosRequestConfig } from 'axios';
import ClientServices from './ClientServices';


let axiosConfig = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
    },
})


axiosConfig.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export interface RefreshTokenLayout {
    token: string,
    status: boolean
}
axiosConfig.interceptors.request.use(
    (config: InternalAxiosRequestConfig): InternalAxiosRequestConfig => {
        const token = getAccessToken();
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }
        const token_csrf: HTMLMetaElement | null = document.head.querySelector('meta[name="csrf-token"]');

        if (token_csrf) {
            config.headers['X-CSRF-TOKEN'] = token_csrf.content;
        }

        return config;
    },
    (error: AxiosError): Promise<AxiosError> => Promise.reject(error)
);

let countRetry = 0
axiosConfig.interceptors.response.use(
    (response: AxiosResponse): AxiosResponse => {
        countRetry = 0
        return response.data
    },
    async (error: AxiosError): Promise<AxiosError> => {
        const status = error.response?.status;
        if (status === 401 && countRetry < 1) {
            countRetry++;
            try {
                var refreshToken = getRefreshToken();
                const dataRefresh: RefreshTokenLayout = await ClientServices.getRefreshToken(refreshToken);
                if (dataRefresh?.status) {
                    clearAcessToken();
                    saveAccessToken(dataRefresh?.token, 7); // set lại token
                    error.config.headers.Authorization = dataRefresh?.token
                    countRetry = 0
                }

                return axiosConfig(error.config as InternalAxiosRequestConfig);
            } catch (retryError) {
                countRetry = 0;
                clearAcessToken();
                window.location.href = '/'
                return Promise.reject((retryError as AxiosError).response?.data || retryError);
            }
        }
        // else if (status === 401) {
        //     window.location.href = '/login';
        // }
        // else if (status === 403) {
        //     window.location.href = '/403';
        // } else if (status === 500) {
        //     // console.log(error, 'error')
        //     window.location.href = `/404`;
        // }
        countRetry = 0;
        return Promise.reject(error.response?.data || error);
    }
);


export default axiosConfig;
