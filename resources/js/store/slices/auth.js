import { createAsyncThunk, createSlice } from '@reduxjs/toolkit';
import GeneralService from '../../Services/GeneralService.jsx';

const initialState = {
    user: null,
    isAuthenticated: false,
    isAdmin: false,
    error: '',
    loading: false,
}

export const getUserCurrent = createAsyncThunk('/user/getCurrenUser', async (data, { rejectWithValue }) => {
    const response = await GeneralService.getCurrentUser();
    if (response.status < 200 || response.status >= 300 || !response)
        return rejectWithValue(response)

    return response;

})

export const logOutUser = createAsyncThunk('/logout', async (data, { rejectWithValue }) => {
    const response = await GeneralService.logout()
    if (response.status < 200 || response.status >= 300 || !response)
        return rejectWithValue(response)

    return response;

})


const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        login: (state, request) => {

        },
        clearMessgage: (state, action) => {
            state.message = '';
        },

        logout: (state) => {
            state.isAuthenticated = false;
            state.isAdmin = false;
            state.currentUser = null
        },



    },
    extraReducers: (builder) => {
        builder.addCase(getUserCurrent.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(getUserCurrent.fulfilled, (state, action) => {
            state.loading = false;
            state.isAuthenticated = true;
            state.user = action.payload.data;
            state.isAdmin = action.payload.data.role == constants.ADMIN ? true : false;
        });

        builder.addCase(getUserCurrent.rejected, (state, action) => {
            state.loading = false;
            state.isAuthenticated = false;
            state.isAdmin = null;
            state.user = null;
            state.error = 'Có lỗi xảy ra !!!';
        });


        builder.addCase(logOutUser.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(logOutUser.fulfilled, (state, action) => {
            state.loading = false;
            state.isAuthenticated = false;
            state.user = null;
            state.isAdmin = false;
        });

        builder.addCase(logOutUser.rejected, (state, action) => {
            state.loading = false;
            state.isAuthenticated = false;
            state.isAdmin = null;
            state.user = null;
            state.error = 'Có lỗi xảy ra !!!';
        });
    }
})

export const { login, logout, clearMessgage } = authSlice.actions

export default authSlice.reducer
