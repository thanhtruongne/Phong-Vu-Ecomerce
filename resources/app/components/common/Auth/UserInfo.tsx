import { InputVertical } from "@/components/elements/InputVertical";
import { useClient } from "@/contexts/ClientProvider";
import ClientServices from "@/services/ClientServices";
import { enumKeyQuery, regexExpression } from "@/utils/constants.types";
import showMessage from "@/utils/showMessage";
import { EditOutlined } from "@ant-design/icons";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { Button, Form, Modal, Select, Skeleton } from "antd";
import { useEffect, useMemo, useState } from "react";
import AddressMount from "./components/AddressMount";

const handleAPIsubmitUser = async (values) => {
    const response = await ClientServices.submitUserInfo(values);
    if (!response) {
        throw new Error("No data returned from API");
    }
    return response.data;
};

const UserInfo = () => {
    const { user, isLoadingUser } = useClient();
    const [form] = Form.useForm();
    const [isModalOpen, setOpenModal] = useState(false);
    const queryClient = useQueryClient();

    const defaultAddress = useMemo(() => {
        return user?.users_address?.find((item) => item?.default)?.id ?? null;
    }, [user?.users_address]);

    const optionsDefaultAddress = useMemo(() => {
        return user?.users_address?.map((item) => ({
            label: item.address_split,
            value: item.id,
        })) ?? [];
    }, [user?.users_address]);

    const handleCloseModal = () => {
        setOpenModal(false);
        form.resetFields();
    };

    const handleSubmitUserInfo = useMutation({
        mutationFn: handleAPIsubmitUser,
        onSuccess: async () => {
            await queryClient.invalidateQueries({ queryKey: [enumKeyQuery.PROVIDER_CURRENT_USER] });
            showMessage("User info updated successfully", "success");
            setOpenModal(false);
        },
        onError: (error) => {
            showMessage(`Failed to update user info: ${error.message}`, "error");
        },
    });

    useEffect(() => {
        if (user) {
            form.setFieldsValue({
                full_name: user.full_name,
                email: user.email,
                phone: user.phone,
                address_default: defaultAddress,
            });
        }
    }, [user, form, defaultAddress, isModalOpen]);

    const renderInfoItem = (label, value) => (
        <div className="w-full py-4 flex items-center gap-6 justify-between border-b border-b-[#e4e4e7] last:border-b-0">
            <div className="text-base text-[#71717a] font-normal">{label}:</div>
            <div className="text-base text-[#1d1d20] text-right font-medium">{value ?? "-"}</div>
        </div>
    );

    return (
        <div className="space-y-4">
            <div className="p-4 bg-white rounded-lg">
                <div className="flex justify-between items-center">
                    <div className="text-lg font-bold">Thông tin cá nhân</div>
                    <Button
                        type="primary"
                        icon={<EditOutlined />}
                        onClick={() => setOpenModal(true)}
                        className="btn-primary"
                    >
                        Cập nhật
                    </Button>
                </div>

                <div className="mt-4">
                    {isLoadingUser ? (
                        <div className="grid grid-cols-2 gap-10">
                            {Array(2).fill(null).map((_, index) => (
                                <Skeleton key={index} active paragraph={{ rows: 2 }} />
                            ))}
                        </div>
                    ) : (
                        <div className="grid grid-cols-2 gap-10">
                            <div>
                                {renderInfoItem("Họ và tên", user?.full_name)}
                                {renderInfoItem("Email", user?.email)}
                            </div>
                            <div>
                                {renderInfoItem("Số điện thoại", user?.phone)}
                                {renderInfoItem("Địa chỉ mặc định", user?.address_default_split)}
                            </div>
                        </div>
                    )}
                </div>
            </div>

            <Modal
                title="Cập nhật thông tin"
                className="modal-address"
                width={600}
                open={isModalOpen}
                footer={null}
                centered
                onCancel={handleCloseModal}
                aria-label="Update user info modal"
            >
                <Form
                    form={form}
                    layout="vertical"
                    onFinish={(values) => handleSubmitUserInfo.mutate(values)}
                    className="p-4 bg-white rounded-lg"
                >
                    <InputVertical name="id" hidden type="hidden" />

                    <InputVertical
                        name="full_name"
                        label="Họ và tên"
                        type="text"
                        placeholder="Nhập họ và tên"
                        rules={[{ required: true, message: "Họ và tên không được bỏ trống!" }]}
                        inputProps={{ size: "large" }}
                    />

                    <InputVertical
                        name="email"
                        label="Email"
                        type="text"
                        placeholder="Email"
                        rules={[
                            { required: true, message: "Email không được bỏ trống!" },
                            { pattern: regexExpression.EMAIL_REGEX, message: "Email không hợp lệ!" },
                        ]}
                        inputProps={{ size: "large" }}
                    />

                    <InputVertical
                        name="phone"
                        label="Số điện thoại"
                        type="text"
                        placeholder="Số điện thoại"
                        rules={[
                            { required: true, message: "Số điện thoại không được bỏ trống!" },
                            { pattern: regexExpression.PHONE_REGEX, message: "Số điện thoại không hợp lệ!" },
                        ]}
                        inputProps={{ size: "large" }}
                    />

                    {optionsDefaultAddress.length > 0 && (
                        <Form.Item
                            label="Địa chỉ mặc định"
                            name="address_default"
                            rules={[{ required: true, message: "Địa chỉ mặc định không được bỏ trống!" }]}
                        >
                            <Select
                                showSearch
                                placeholder="Chọn địa chỉ mặc định"
                                filterOption={(input, option) =>
                                    option?.label?.toLowerCase().includes(input.toLowerCase())
                                }
                                options={optionsDefaultAddress}
                                size="large"
                            />
                        </Form.Item>
                    )}

                    <Form.Item className="pt-4 mb-0">
                        <Button
                            type="primary"
                            htmlType="submit"
                            className="btn-primary w-full"
                            loading={handleSubmitUserInfo.isLoading}
                        >
                            Cập nhật
                        </Button>
                    </Form.Item>
                </Form>
            </Modal>

            <div className="p-4 bg-white rounded-lg">
                <AddressMount data={user} isLoading={isLoadingUser} />
            </div>
        </div>
    );
};

export default UserInfo;
