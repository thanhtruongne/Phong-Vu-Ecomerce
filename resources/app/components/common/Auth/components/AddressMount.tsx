import { InputVertical } from "@/components/elements/InputVertical";
import ClientServices from "@/services/ClientServices";
import { enumKeyQuery } from "@/utils/constants.types";
import showMessage from "@/utils/showMessage";
import { ExclamationCircleFilled, LoadingOutlined, PlusOutlined } from "@ant-design/icons";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { Badge, Button, Col, Divider, Empty, Form, Modal, Row, Select, Skeleton, Spin, Switch } from "antd";
import { useCallback, useMemo, useState } from "react";
interface OptionType {
    value: string;
    label: string;
}


const handleApiSaveResponse = async (values) => {
    try {
        const response = await ClientServices.saveAddressUser(values);
        return response;
    } catch (error) {
        const errorMessage =
            error instanceof Error ? error.message : "Lỗi không xác định";
        throw new Error(errorMessage);
    }
}

const handleGetProvinces = async () => {
    try {
        const response = await ClientServices.getDataAddressCode(null);
        return response?.data;
    } catch (error) {
        const errorMessage =
            error instanceof Error ? error.message : "Lỗi không xác định";
        throw new Error(errorMessage);
    }
}

const handleGetDetailAddress = async (id: number) => {
    try {
        const response = await ClientServices.getDetailAddressById(id);
        return response?.data;
    } catch (error) {
        const errorMessage =
            error instanceof Error ? error.message : "Lỗi không xác định";
        throw new Error(errorMessage);
    }
}


const handleGetWardByProvinceCode = async (params) => {
    try {
        const response = await ClientServices.getDataAddressCode(params);
        return response?.data;
    } catch (error) {
        const errorMessage =
            error instanceof Error ? error.message : "Lỗi không xác định";
        throw new Error(errorMessage);
    }
}


const handleRemoveAddress = async (id: number) => {
    try {
        const response = await ClientServices.removeAddressByyID(id);
        return response;
    } catch (error) {
        const errorMessage =
            error instanceof Error ? error.message : "Lỗi không xác định";
        throw new Error(errorMessage);
    }
}

const { confirm } = Modal;

const AddressMount = ({ data, isLoading }) => {
    const [form] = Form.useForm();
    const [isModalOpen, setIsModalOpen] = useState<boolean>(false);
    const [optionDistrict, setOptionDistrict] = useState<OptionType[]>([]);
    const [isSpining, setSpining] = useState<boolean>(false)
    const queryClient = useQueryClient();


    const { data: codeData } = useQuery({
        queryKey: [enumKeyQuery.LOAD_ADDRESS_CODE],
        queryFn: handleGetProvinces,
        staleTime: 10 * 24 * 60 * 60 * 1000,
        gcTime: 30 * 24 * 60 * 60 * 1000
    })

    const saveAddressMutation = useMutation({
        mutationFn: handleApiSaveResponse,
        onSuccess: (response) => {
            showMessage(response?.message)
            setIsModalOpen(false);
            form.resetFields();
            queryClient.invalidateQueries({ queryKey: [enumKeyQuery.PROVIDER_CURRENT_USER] });
        },
        onError: (error: Error) => {
            showMessage(`Lưu địa chỉ thất bại: ${error.message}`, 'error');
        },
    })


    const handleGetWardByCode = useMutation({
        mutationFn: (params: { code: string }) => handleGetWardByProvinceCode({ code: params.code }),
        onSuccess: (response) => {
            form.resetFields(['ward_code'])
            setOptionDistrict(response);
        },
        onError: (error: Error) => {
            showMessage(`Lấy địa chỉ thất bại: ${error.message}`, 'error');
        },
    })

    const mutationDeleteAddress = useMutation({
        mutationFn: (id: number) => handleRemoveAddress(id),
        onSuccess: async (response) => {
            await queryClient.invalidateQueries({ queryKey: [enumKeyQuery.PROVIDER_CURRENT_USER] });
            showMessage(response?.message)
            setSpining(false)
            setIsModalOpen(false);
        },
        onError: (error: Error) => {
            showMessage(`Lỗi khi lấy detail code ${error.message}`, 'error');
        },
    })

    const handleGetDetailAddressById = useMutation({
        mutationFn: (id: number) => handleGetDetailAddress(id),
        onSuccess: async (response) => {
            await handleGetWardByCode.mutateAsync({ code: response?.province_code }) // trigger change
            form.setFieldsValue(response)
        },
        onError: (error: Error) => {
            showMessage(`Lỗi khi lấy detail code ${error.message}`, 'error');
        },
    })

    const showConfirm = (id: number) => {
        confirm({
            title: 'Delete Address',
            icon: <ExclamationCircleFilled />,
            content: 'Bạn có muốn xóa địa chỉ này !',
            onOk() {
                setSpining(true)
                mutationDeleteAddress.mutate(id)
            },
            onCancel() {
                console.log('Cancel');
            },
        });
    };



    const handleCloseModal = useCallback((): void => {
        form.resetFields();
        setOptionDistrict([]);
        setIsModalOpen(false)
    }, [form])

    const handleEditAddress = useCallback(async (id: number): Promise<void> => {
        setSpining(true)
        await handleGetDetailAddressById.mutateAsync(id);
        setSpining(false)
        setIsModalOpen(true)
    }, [handleGetDetailAddressById])



    const handleOnChangeProvince = useCallback((values) => {
        handleGetWardByCode.mutate({ code: values })
    }, [handleGetWardByCode])

    const memoizedProvinces = useMemo(() => codeData || [], [codeData]);
    const memoizedOptionDistrict = useMemo(() => optionDistrict, [optionDistrict]);

    return (
        <div className="">
            <Spin spinning={isSpining} indicator={<LoadingOutlined spin />} fullscreen />
            <Row className="" gutter={24}>
                <Col span={12}>
                    <h1 className="mb-3 font-bold">Địa chỉ</h1>
                </Col>
                <Col span={12} className="text-end">
                    <Form.Item>
                        <Button
                            loading={saveAddressMutation.isPending}
                            disabled={saveAddressMutation.isPending}
                            onClick={() => setIsModalOpen(true)}
                            type="primary"
                            icon={<PlusOutlined />}
                            className="btn-primary">Thêm địa chỉ</Button>
                    </Form.Item>
                </Col>
            </Row>

            <div className="">
                <div className="w-full mt-2">
                    {isLoading ? (
                        <div className="w-full grid grid-cols-2 gap-[12px]">
                            {
                                Array(4).fill(null).map(() => {
                                    return <Skeleton active paragraph={{ rows: 2 }}></Skeleton>
                                })
                            }
                        </div>
                    ) : (
                        <div className="">
                            <div className={`w-full grid ${data?.users_address.length > 0 ? `grid-cols-2` : 'grid-cols-1'} gap-[12px]`}>
                                {data?.users_address.length > 0 ? data.users_address.map((item) => {
                                    return (
                                        <Badge.Ribbon style={item?.default != 1 ? { display: "none" } : {}}
                                            text={'mặc định'} >
                                            <div className="w-full p-[16px] flex flex-col gap-[4px] rounded-lg bg-purewhite relative">
                                                <span className="text-neutral font-bold">{item?.receiver_name}</span>
                                                <div className="flex flex-1 flex-col gap-[4px]">
                                                    <span className="text-neutral "> {data?.full_name} <span className="mx-2">|</span> {data?.phone}</span>
                                                    <div className="w-full text-neutral font-regular">
                                                        {item?.address_split}
                                                    </div>
                                                </div>
                                                <div className="flex items-center justify-end gap-1 w-full mt-3">
                                                    <Button color="danger" variant="dashed" onClick={() => showConfirm(item.id)}>
                                                        Xóa
                                                    </Button>
                                                    <Button className="btn-primary" type="primary" onClick={() => handleEditAddress(item.id)}>
                                                        Cập nhật
                                                    </Button>
                                                </div>
                                            </div>
                                        </Badge.Ribbon>
                                    )
                                })
                                    : (
                                        <Empty description={<span>Chưa có thông tin địa chỉ</span>}></Empty>
                                    )}
                            </div>
                        </div>
                    )}

                </div>
            </div>
            <Modal
                title="Thêm địa chỉ"
                className="modal-address"
                width={600}
                closable={{ 'aria-label': 'Custom Close Button' }}
                open={isModalOpen}
                footer={null}
                centered
                onCancel={handleCloseModal}
            >
                <Form
                    form={form}
                    layout={'vertical'}
                    onFinish={(values) => saveAddressMutation.mutate(values)}
                    className="p-4 bg-white rounded-lg"
                >
                    <InputVertical
                        name="id"
                        hidden={true}
                        type="hidden"
                    />

                    <Form.Item
                        label="Tỉnh/Thành phố"
                        rules={[
                            { required: true, message: "Tỉnh/Thành phố này không được bỏ trống !" }
                        ]}
                        name='province_code'
                    >
                        <Select
                            showSearch
                            placeholder="Tìm thành phố"
                            filterOption={(input, option) =>
                                (option?.label ?? '')?.toLowerCase().includes(input.toLowerCase())
                            }
                            onChange={handleOnChangeProvince}
                            options={memoizedProvinces}
                        />
                    </Form.Item>
                    <Form.Item
                        label="Quận/Huyện"
                        rules={[
                            { required: true, message: "Quận/Huyện này không được bỏ trống !" }
                        ]}
                        name='ward_code'
                    >
                        <Select
                            showSearch
                            placeholder="Tìm Quận/Huyện"
                            filterOption={(input, option) =>
                                (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                            }
                            options={memoizedOptionDistrict}
                            loading={handleGetWardByCode.isPending}
                            disabled={!form.getFieldValue("province_code")}
                        />


                    </Form.Item>

                    <InputVertical
                        name="address"
                        label="Địa chỉ"
                        type="text"
                        placeholder="Địa chỉ"
                        rules={[
                            { required: true, message: "Địa chỉ không được bỏ trống !" }
                        ]}
                        inputProps={{ size: 'large' }}
                    />

                    <InputVertical
                        name="receiver_name"
                        label="Tên người nhận"
                        type="text"
                        placeholder="Tên người nhận"
                        rules={[
                            { required: true, message: "Tên người nhận không được bỏ trống !" }
                        ]}
                        inputProps={{ size: 'large' }}
                    />
                    <Divider variant="dotted" style={{ borderColor: '#7cb305', margin: '10px 0' }} />

                    <Form.Item layout="horizontal" label="Đặt làm mặc định" name="default" valuePropName="checked">
                        <Switch />
                    </Form.Item>

                    <Form.Item className="w-full pt-4 mb-0">
                        <Button type="primary" htmlType="submit" className="btn-primary w-full">Cập nhật</Button>
                    </Form.Item>
                </Form>
            </Modal>
        </div >
    )
}

export default AddressMount
