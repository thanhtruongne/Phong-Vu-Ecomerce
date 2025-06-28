import axiosConfig, { RefreshTokenLayout } from "./axiosCongfig";



class GeneralService {
    async getCategories(): Promise<[]> {
        return await axiosConfig.get('/api/get-categories')
    }

    async getRefreshToken(refreshToken: string): Promise<RefreshTokenLayout> {
        return await axiosConfig.post('/api/refresh-token', refreshToken)
    }

    async getCurrentUser(): Promise<[]> {
        return await axiosConfig.get('/api/user')
    }

    async handleSaveCallbackGoogle(queryParams): Promise<[]> {
        return await axiosConfig.get('/api/google/callback' + queryParams)
    }

    async logout() {
        return await axiosConfig.post('/api/logout')
    }

    async getDataLayout(): Promise<[]> {
        return await axiosConfig.get('/api/get-data-layout');
    }

    async getDataAddressCode(params: any): Promise<[]> {
        return await axiosConfig.get('/api/get-address-code', { params });
    }

    async getDetailAddressById(id: number): Promise<[]> {
        return await axiosConfig.get('/api/get-address-detail-code/' + id);
    }

    async removeAddressByyID(id: number): Promise<[]> {
        return await axiosConfig.delete('/api/remove-address/' + id);
    }

    async saveAddressUser(payload): Promise<[]> {
        return await axiosConfig.post('/api/user/save-address', payload);
    }

    async submitUserInfo(payload): Promise<[]> {
        return await axiosConfig.post('/api/user/save-user-info', payload);
    }

    async getUrlLoginDriver(): Promise<[]> {
        return await axiosConfig.get('/api/sign-google-login');
    }

}


export default new GeneralService();
