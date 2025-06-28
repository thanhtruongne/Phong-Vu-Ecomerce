import ClientServices from "@/services/ClientServices";
import { LoginDriver } from "@/types/index.types";
import { enumKeyQuery } from "@/utils/constants.types";
import { useQuery } from "@tanstack/react-query";
import { Skeleton } from "antd";
import { Link, useNavigate } from "react-router-dom";




const LoginAuth = () => {
    const navigate = useNavigate();

    const handleGetUrlLogin = async (): Promise<LoginDriver> => {
        try {
            const response = await ClientServices.getUrlLoginDriver();
            console.log(response)
            return response.data;
        } catch (error) {
            const errorMessage = error instanceof Error ? error.message : "Lỗi không xác định";
            throw new Error(errorMessage);
        }
    }

    const { data, isLoading } = useQuery({
        queryKey: [enumKeyQuery.LOGIN_REDIRECT],
        queryFn: handleGetUrlLogin,
        staleTime: 5 * 60 * 1000,
    })

    const GoogleIcon = () => (
        <svg width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M44.5 24C44.5 22.0629 44.2917 20.1794 43.875 18.375H24V28.8125H34.6667C34.0417 31.9844 32.3333 34.6875 29.875 36.5625V42.5625H36.5417C40.9167 39.0312 44.5 34.0312 44.5 24Z"
                fill="#4285F4"
            />
            <path
                d="M24 48C29.9167 48 35 45.6875 38.4583 41.5625L29.875 36.5625C27.9167 37.9375 25.4167 38.8125 24 38.8125C19.3333 38.8125 15.25 35.7188 13.5833 31.5H6V37.5C9.58333 43.3125 16.3333 47.8125 24 48Z"
                fill="#34A853"
            />
            <path
                d="M13.5833 31.5C12.7917 29.625 12.3333 27.5625 12.3333 25.3125C12.3333 23.0625 12.7917 21 13.5833 19.125V13.125H6.04167C4.08333 16.6875 3 20.6875 3 24.8125C3 28.9375 4.08333 32.9375 6.04167 36.5L13.5833 31.5Z"
                fill="#FBBC05"
            />
            <path
                d="M24 12.1875C27.0833 12.1875 29.9167 13.3125 32.125 15.3125L38.5417 8.875C35 5.625 29.9167 3.375 24 3.375C16.3333 3.375 9.58333 7.875 6.04167 13.125L13.5833 19.125C15.25 14.875 19.3333 12.1875 24 12.1875Z"
                fill="#EA4335"
            />
        </svg>
    );

    return (
        <div className="flex flex-col items-center justify-center h-screen bg-gray-100">
            {isLoading ? <Skeleton active /> : (
                <div className="text-center">
                    {/* <h2 className="text-2xl font-bold mb-4">Đăng nhập vào hệ thống Ercomerce</h2> */}
                    <div className="space-x-4 flex flex-col">
                        <Link
                            to={data?.url_google}
                            className="flex items-center justify-center w-full max-w-xs px-4 py-2 border border-gray-300 rounded-full hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"

                        >
                            <GoogleIcon />
                            Login with Google
                        </Link>
                    </div>
                </div>

            )
            }
        </div >
    )
}


export default LoginAuth;
