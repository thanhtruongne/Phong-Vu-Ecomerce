import { BannerPage } from "@/components/common/BannerPage";
import { useClient } from "@/contexts/ClientProvider";

const HomePage = () => {
    const { slider } = useClient();
    return (
        <div className="body-root">
            <div className="">
                <div className="banner">
                    <BannerPage data={slider} />
                </div>
            </div>

        </div>
    );
};
export default HomePage;
