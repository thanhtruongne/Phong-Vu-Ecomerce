import GoogleCallback from "@/components/common/GoogleCallback";
import HomePage from "@/pages/HomePage";
import LoginAuth from "@/pages/Login";
import UserPage from "@/pages/UserPage";
import { RouteObject } from "react-router-dom";
import CilenPath from "../RoutePaths/CilenPath";

const ClientRoute: RouteObject[] = [
    {
        path: CilenPath.HOME,
        element: <HomePage />
    },
    {
        path: CilenPath.LOGIN,
        element: <LoginAuth />
    },
    {
        path: CilenPath.DETAIL_USER,
        element: <UserPage />
    },
    {
        path: CilenPath.CALLBACK_LOGIN_GOOGLE,
        element: <GoogleCallback />
    }
];

export default ClientRoute;
