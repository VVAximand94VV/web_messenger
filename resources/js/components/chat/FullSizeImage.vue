<template>
    <div class="modal fade" :id="`full-size-img-${imageId}`" tabindex="-1" aria-labelledby="full-size-img" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered m-auto">
            <div class="modal-content">
                <img :src="src" class="full-size-image img-fluid" alt="full size img">
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "FullSizeImage",

    props:['imageId','src',],
}
</script>

<style scoped>
.full-size-image{

}
</style>
