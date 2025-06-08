import instance from "../utils/axios";


class GeneralService {
    async getCategories() {
        return await instance.get('/get-categories')
    }

    async getCurrentUser() {
        return await instance.get('/user/getCurrentUser')
    }

    async logout() {
        return await instance.post('/logout')
    }


    async login(payload) {

    }

    async register(payload) {

    }
}


export default new GeneralService();
