import { Notify } from "@/contexts/ClienContext.types";
import { Avatar, List, Typography } from "antd";


interface NotifyListProps {
    data: Notify[];
}
const NotifyList: React.FC<NotifyListProps> = ({ data }) => {
    return (
        <List
            className="w-[380px]"
            header={
                <Typography.Title level={5} style={{ margin: 0 }}>
                    Thông báo
                </Typography.Title>
            }
            itemLayout="horizontal"
            dataSource={data}
            renderItem={(item, index) => (
                <List.Item>
                    <List.Item.Meta
                        avatar={<Avatar src={`https://api.dicebear.com/7.x/miniavs/svg?seed=${index}`} />}
                        title={<a href="https://ant.design">{item.title}</a>}
                        description="Ant Design, a design language for background applications, is refined by Ant UED Team"
                    />
                </List.Item>
            )}
        />
    )
}


export default NotifyList
