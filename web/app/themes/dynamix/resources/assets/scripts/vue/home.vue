<template>
    <div class="main-content">
      test appp comp {{webpack}}
    </div>
</template>
<script>
    export default {
      name: "Home",
        data: () => ({
          // reactive data property of the component.
          webpack: 'Powered by home!',
      }),
      mounted: function() {
        console.log('test mounted', this.webpack);
      },
    }
</script>
