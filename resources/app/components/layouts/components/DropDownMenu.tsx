import { CagetoryItem } from '@/contexts/ClienContext.types';
import { BarsOutlined } from '@ant-design/icons';
import type { MenuProps } from 'antd';
import { Dropdown, Space } from "antd";
import { FC } from 'react';
import { Link } from 'react-router-dom';

type MenuItem = Required<MenuProps>['items'][number];


const transformCategoriesToMenuItems = (data: CagetoryItem[]): MenuItem[] => {
    return data?.map((category) => {
        const item: MenuItem = {
            key: category.id.toString(),
            // icon: category.icon,
            label: category.url ? (
                <Link to={`/${category.url}`}>{category.name}</Link>
            ) : (
                category.name
            ),
        };

        if (category.children && category.children.length > 0) {
            item.children = transformCategoriesToMenuItems(category.children);
        }

        return item;
    });
};

interface DropDownMenuProps {
    data: CagetoryItem[];
}

const DropDownMenu: FC<DropDownMenuProps> = ({ data }) => {
    const items: MenuItem[] = transformCategoriesToMenuItems(data);

    return (
        <Dropdown menu={{ items }} trigger={['click']} className='w-[300]'>
            <Link to={'#'} onClick={(e) => e.preventDefault()} className='border px-3 py-2 rounded-lg'>
                <Space>
                    <BarsOutlined />
                    Danh mục sản phẩm
                </Space>
            </Link>
        </Dropdown>

    )



}


export default DropDownMenu;
