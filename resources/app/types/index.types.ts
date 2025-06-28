import { ItemSlider } from "@/components/common/Slicks/SlickSlider";
import { Rule } from "antd/es/form";
import type { InputProps, TextAreaProps } from 'antd/es/input';


export interface LayoutData {
    slider: ItemSlider[] | [],
}


export interface LoginDriver {
    url_google: string | null,
    url_facebook: string | null
}

export interface ResponseTokenGoogle {
    token: string,
    refreshToken: string,
    status: boolean | false,
    email: string
}


//custom element

export interface InputVerticalProps {
    label?: string;
    name: string;
    rules?: Rule[] | null;
    prefix?: React.ReactNode;
    className?: string | '';
    suffix?: React.ReactNode;
    placeholder?: string | null,
    hidden?: boolean | false;
    type?: 'text' | 'password' | 'textarea' | 'hidden';
    disabled?: boolean;
    loading?: boolean;
    inputProps?: InputProps;
    textAreaProps?: TextAreaProps;
}

