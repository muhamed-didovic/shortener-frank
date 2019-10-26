<template>
  <div id="app">
    <message></message>
    <router-view></router-view>
  </div>
</template>

<script>
  import Message from './app/global/components/Message'

  export default {
    name: 'app',
    components: {
      Message
    }
  }
</script>

<style lang="scss">
  @import '../../sass/shortener';
</style>
