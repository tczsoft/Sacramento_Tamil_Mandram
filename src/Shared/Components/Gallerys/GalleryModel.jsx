import React from 'react'
import Lightbox from 'yet-another-react-lightbox';
import { Counter, Thumbnails , Zoom} from 'yet-another-react-lightbox/plugins';
import "yet-another-react-lightbox/plugins/counter.css";
import "yet-another-react-lightbox/styles.css";
import "yet-another-react-lightbox/plugins/thumbnails.css";
import apiurl from '../../services/apiendpoint/apiendpoint';

export default function GalleryModel(props) {
    const {setVisible,Visible, ModelData} = props;
    const GalleryData = ModelData.Image.split(',').map(items=>({
      src: `${apiurl()}/${items}`,
      width: 3840,
      height: 5760
  })) ;

  
  return (
    <>
      {GalleryData && <Lightbox open={Visible} close={() => setVisible(false)} slides={GalleryData} plugins={[Thumbnails,Zoom,Counter]} />}
    </>
  )
}
