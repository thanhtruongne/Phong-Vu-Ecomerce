import ClientServices from "@/services/ClientServices";
import { enumKeyQuery } from "@/utils/constants.types";
import { getAccessToken } from "@/utils/cookies";
import { useQuery } from "@tanstack/react-query";
import { createContext, useContext } from "react";
import { ChildrenNode, ClientContextType, DetailDataUser } from "./ClienContext.types";

export const ClientContext = createContext<ClientContextType>({
    menu: [],
    isAuthenticated: false,
    isLoadingUser: false,
    user: null,
    newNotifies: { data: [], totalUnread: 0, type: null, loading: true },
    dataCategories: [],
    isLoading: false,
    slider: [],
})


const ClientProvider: React.FC<ChildrenNode> = ({ children }) => {

    const handleGetDataLayout = async (): Promise<ClientContextType> => {
        try {
            const response = await ClientServices.getDataLayout();
            return response?.data;
        } catch (error) {
            const errorMessage = error instanceof Error ? error.message : "Lỗi không xác định";
            throw new Error(errorMessage);
        }
    }

    const handleGetDetailUser = async (): Promise<DetailDataUser | null> => {
        try {
            const response = await ClientServices.getCurrentUser();
            return response;
        } catch (error) {
            const errorMessage = error instanceof Error ? error.message : "Lỗi không xác định";
            throw new Error(errorMessage);
        }
    }


    const { data, isLoading } = useQuery({
        queryKey: [enumKeyQuery.LAYOUT],
        queryFn: handleGetDataLayout,
        staleTime: 5 * 60 * 1000,
        gcTime: 10 * 60 * 1000
    })

    const { data: userData, isError, isLoading: userLoading } = useQuery({
        queryKey: [enumKeyQuery.PROVIDER_CURRENT_USER],
        queryFn: handleGetDetailUser,
        staleTime: 5 * 60 * 1000,
        gcTime: 10 * 60 * 1000,
        retry: 0,
        refetchOnWindowFocus: false,
        refetchInterval: false,
        enabled: getAccessToken() ? true : false
    })



    return (
        <ClientContext.Provider
            value={{
                menu: data?.menu,
                isAuthenticated: getAccessToken() && !isError,
                user: userData?.data,
                isLoadingUser: userLoading,
                newNotifies: data?.newNotifies,
                dataCategories: data?.dataCategories,
                slider: data?.slider,
                isLoading
            }}
        >
            {children}
        </ClientContext.Provider>
    )
}

export function useClient(): ClientContextType {
    const context = useContext(ClientContext);
    if (!context) {
        throw new Error('useClient phải được sử dụng bên trong ClientProvider');
    }
    return context;
}



export default ClientProvider;
