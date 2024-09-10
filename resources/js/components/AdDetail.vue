<template>
    <div class="ad-detail">

        <h1>{{ ad.title || 'No title available' }}</h1>
        <img :src="ad.main_image || 'default-image.jpg'" alt="ad image" class="ad-image" />
        <p class="ad-price">${{ ad.price || 'Price not available' }}</p>
        <p v-if="ad.description && showDescription" class="ad-description">{{ ad.description }}</p>
        <button @click="goBack" class="back-button">Back</button>

        <button v-if="ad.description" @click="toggleDescription" class="toggle-description-button">
            {{ showDescription ? 'Hide Description' : 'Show Description' }}
        </button>

        <div v-if="ad.images && ad.images.length > 0" class="ad-images">
            <h2>Additional Images</h2>
            <div v-for="(image, index) in ad.images" :key="index" class="ad-image-container">
                <img :src="image" alt="Additional ad image" class="ad-image" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ad: {},
            showDescription: false,
        };
    },
    methods: {
        async fetchAd() {
            try {

                const response = await fetch(`/api/adverts/${this.$route.params.id}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                this.ad = data.data;
            } catch (error) {
                console.error('Error fetching ad details:', error);
            }
        },
        toggleDescription() {
            this.showDescription = !this.showDescription;
        },
        goBack() {
            this.$router.back();
        },
    },
    mounted() {
        this.fetchAd();
    },
};
</script>

<style scoped>
.ad-detail {
    padding: 1rem;
    max-width: 600px;
    margin: auto;
}
.ad-image {
    max-width: 100%;
    height: auto;
    margin-bottom: 1rem;
}

.ad-price {
    font-size: 1.125rem;
    color: #007bff;
    font-weight: bold;
}

.ad-description {
    margin: 1rem 0;
}

.toggle-description-button {
    margin-left: 25px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    border-radius: 0.25rem;
}

.toggle-description-button:hover {
    background-color: #0056b3;
}

.ad-images {
    margin-top: 1rem;
}

.ad-image-container {
    margin-bottom: 0.5rem;
}

.ad-image-container img {
    max-width: 100%;
    height: auto;
}

.back-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    border-radius: 0.25rem;
    margin-bottom: 1rem;
}

.back-button:hover {
    background-color: #0056b3;
}
</style>
