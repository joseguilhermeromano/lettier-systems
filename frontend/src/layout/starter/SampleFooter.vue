<template>
  <footer class="footer">
    <div class="container-fluid">
      <div class="copyright">
        © {{ year }} desenvolvido com <i class="tim-icons icon-heart-2"></i> por
        <a
          href="https://www.linkedin.com/in/jose-guilherme-romano"
          target="_blank"
          rel="noopener"
          >José Romano</a
        >
      </div>
    </div>
  </footer>
</template>
<script>
export default {
  data() {
    return {
      year: new Date().getFullYear(),
    };
  },
};
</script>
<style></style>
