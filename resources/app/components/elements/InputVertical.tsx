import { InputVerticalProps } from "@/types/index.types";
import { LoadingOutlined } from "@ant-design/icons";
import { Form, Input } from "antd";
import { FC } from "react";



export const InputVertical: FC<InputVerticalProps> = (
    { label,
        name,
        rules,
        className = '',
        placeholder,
        type = 'text',
        prefix,
        suffix,
        disabled,
        loading,
        inputProps,
        textAreaProps,
        hidden = false,
        ...rest }
) => {



    return (
        <Form.Item
            label={label}
            name={name}
            rules={rules}
            className={className}
            hidden={hidden}
        >
            {type === 'textarea' ? (
                <Input.TextArea
                    placeholder={placeholder}
                    disabled={disabled || loading}
                    {...textAreaProps}
                    {...rest}
                />
            ) : (
                <Input
                    type={type}
                    prefix={prefix}
                    suffix={loading ? <LoadingOutlined /> : suffix}
                    placeholder={placeholder}
                    disabled={disabled || loading}
                    {...inputProps}
                    {...rest}
                />
            )}
        </Form.Item>
    );
}
