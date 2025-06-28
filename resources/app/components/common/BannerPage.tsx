import { ItemSlider, SliderAutoPlay } from "./Slicks/SlickSlider";
interface BannerPageProps {
    data: ItemSlider[] | [] | undefined;
}
export const BannerPage = ({ data }: BannerPageProps) => {


    return (
        <div className="mb-3 min-h-[600px]">
            <div className="relative">
                <div className="absolute top-0 left-0 right-0" style={{ zIndex: 0 }}>
                    <SliderAutoPlay data={data || []} />
                </div>

            </div>
        </div>
    )
}
