<template lang="">
    <div>
        <main class="main-container">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
export default {};
</script>

<style lang="css">
.main-container {
    padding: 20px;
    background-color: #f9f9f9;
    min-height: 100vh;
    display: flex; 
    justify-content: center;
    align-items: center;
}

</style>
