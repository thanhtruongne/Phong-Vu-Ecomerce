import Cookies from 'js-cookie';
const COOKIE_NAMES = {
    ACCESS_TOKEN: 'access_token',
    REFRESH_TOKEN: 'refresh_token',
} as const;



export function saveToken(
    accessToken: string,
    refreshToken: string,
    accessTokenExpiry: number = 7,
    refreshTokenExpiry: number = 30
): void {
    saveAccessToken(accessToken, accessTokenExpiry);
    saveRefreshToken(refreshToken, refreshTokenExpiry);
}
export const saveRefreshToken = (
    token: string,
    expiresInDays: number = 30
): void => {

    Cookies.set(COOKIE_NAMES.REFRESH_TOKEN, token, {
        expires: expiresInDays,
        secure: false,
        sameSite: 'strict',
        path: '/'
    });
};

export const saveAccessToken = (
    token: string,
    expiresInDays: number = 7,
): void => {
    Cookies.set(COOKIE_NAMES.ACCESS_TOKEN, token, {
        expires: expiresInDays,
        secure: false,
        sameSite: 'strict',
        path: '/'
    });
};

export const clearAcessToken = (): void => {
    Cookies.remove(COOKIE_NAMES.ACCESS_TOKEN);
}


export const getAccessToken = (): string | null => {
    return Cookies.get(COOKIE_NAMES.ACCESS_TOKEN) || null;
};
export const getRefreshToken = (): string | null => {
    return Cookies.get(COOKIE_NAMES.REFRESH_TOKEN) || null;
};
