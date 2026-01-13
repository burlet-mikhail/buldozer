<script setup>

</script>

<template>
    <div class="loader-container">
        <div class="loader"></div>
    </div>
</template>
<style>
.loader {
    border: 8px solid rgba(255, 255, 255, 0.3);
    border-top: 8px solid #fec005;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

.loader-container {
    background: rgba(255, 255, 255, 0.8);
}

.loader-container {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    z-index: 99;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cities li {
    margin-bottom: 5px;
    cursor: pointer;
}

.cities {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #ffffff;
    z-index: 99;
    padding: 10px !important;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
