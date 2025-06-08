import { configureStore } from '@reduxjs/toolkit';
import { persistReducer, persistStore } from 'redux-persist';
import storage from 'redux-persist/lib/storage';
import authSlice from './auth';
import categorySlice from './category';
const commoinfig = {
    key: 'auth',
    storage,
    version: 1,
};

const userCongig = {
    ...commoinfig,
    whitelist: ['user', 'isAuthenticated'],
};

export const store = configureStore({
    reducer: {
        auth: persistReducer(userCongig, authSlice),
        category: categorySlice
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware({
            serializableCheck: false,
        }),
});

export const persiststore = persistStore(store);
