<template>
  <Gallery :images="images" ></Gallery>
</template>
  
<script>
import Gallery from "./MoaGallery.vue"
import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css';
export default {
  
  name: "Example",
  components: {
    Gallery
  },
  data() {
    return {
      images: [
            {
            title: "title 1",
            description: "des 1",
            href: "https://images.wallpaperscraft.com/image/castle_neuschwanstein_castle_architecture_126354_1280x720.jpg"},
            {
             title: "title 2",
            description: "des 2",
            href: "https://images.unsplash.com/photo-1542029575035-80c8b9d031f9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
            },
     ],
    };
  },
};
</script> 
 
<style scoped>
 
</style> 