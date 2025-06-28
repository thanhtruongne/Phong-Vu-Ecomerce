import ClientServices from "@/services/ClientServices";
import { ResponseTokenGoogle } from "@/types/index.types";
import { saveToken } from "@/utils/cookies";
import { useMutation } from "@tanstack/react-query";
import { useEffect } from "react";
import { useLocation } from "react-router-dom";



const GoogleCallback = () => {
    const location = useLocation();

    const handleCallBackLoginGoogle = async (
        params: string
    ): Promise<ResponseTokenGoogle> => {
        try {
            const response = await ClientServices.handleSaveCallbackGoogle(params);
            return response?.data;

        } catch (error) {
            const errorMessage =
                error instanceof Error ? error.message : "Lỗi không xác định";
            throw new Error(errorMessage);
        }
    };

    const { mutate, isError, error, data } = useMutation({
        mutationFn: handleCallBackLoginGoogle,
        mutationKey: ["googleCallback"],
        onSuccess: (data: ResponseTokenGoogle) => {
            saveToken(data?.token, data?.refreshToken);
            window.location.href = "/";
        },
        onError: (error: Error) => {
            console.error("Lỗi gọi lại Google:", error);
        },
    });

    useEffect(() => {
        if (location.search) {
            mutate(location.search);
        }
    }, [location.search, mutate])

    return null;
};

export default GoogleCallback;
