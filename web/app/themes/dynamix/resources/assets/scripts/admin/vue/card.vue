<template>
    <div class="main-content">
      test appp comp {{webpack}}
    </div>
</template>
<script>
    export default {
      name: "main-content",
        data: () => ({
          // reactive data property of the component.
          webpack: 'Powered by webpack!',
      }),
      mounted: function() {
        console.log('test mounted', this.webpack);
      },
    }
</script>
