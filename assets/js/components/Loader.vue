<template>
    <div class="preloader-dimmer valign-wrapper">
        <div class="preloader-wrapper big active valign">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
        name: 'Loader'
    }
</script>
