<template id="oka">
  <a href="#" @click.prevent="clickHandler()" class="pull-right btn btn-primary">Go ahead, give me a click!</a>
</template>
<script>
export default {
  template:"#oka",
    methods: {
      clickHandler () {
        this.$emit('click');
      }
  }
}
</script>