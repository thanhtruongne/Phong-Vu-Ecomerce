import { ItemSlider } from "@/components/common/Slicks/SlickSlider";
import { ReactNode } from "react";

export interface DetailDataUser {
    data: User | null,
    status: boolean | false
}

export interface User {
    id: number;
    name: string;
    email: string;
    usersAddress?: [];
    role: string;
    avatar: string;
    full_name: string;
}

export interface Notify {
    id: string;
    title: string,
    message: string;
    createdAt: Date;

}
export interface ChildrenNode {
    children: ReactNode
}

export interface NewNotifies {
    data: Notify[];
    totalUnread: number;
    type: string | null;
    loading: boolean;
}

export interface MenuItem {
    id: number;
    name: string;
    path: string | null;
}

export interface ClientContextType {
    menu: MenuItem[] | [];
    isAuthenticated: boolean;
    user: User | null;
    isLoadingUser: boolean;
    newNotifies: NewNotifies;
    dataCategories: CagetoryItem[] | [];
    slider: ItemSlider[] | [],
    isLoading: boolean | false
}


export interface CagetoryItem {
    id: string,
    name: string,
    url: string,
    icon: string | null,
    children: CagetoryItem[] | []
}
