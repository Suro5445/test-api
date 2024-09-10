<template>
    <div class="ads-list">
        <h1 class="title">Advertisements</h1>
        <div v-for="ad in ads" :key="ad.id" class="ad-item">
            <div class="ad-image-container">
                <img :src="ad.main_image" alt="ad image" class="ad-image"/>
            </div>
            <router-link :to="{ name: 'ad-detail', params: { id: ad.id } }" class="ad-title-link">
                <h2 class="ad-title">{{ ad.title }}</h2>
            </router-link>
            <p class="ad-price">${{ ad.price }}</p>

        </div>

        <button v-if="nextPageUrl" @click="loadMore" class="load-more-button">
            Load More
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ads: [],
            page: 1,
            nextPageUrl: null,
            sort: 'asc',
        };
    },
    methods: {
        async fetchAds() {
            const response = await fetch(`/api/adverts?page=${this.page}&sort_direction=${this.sort}`);
            const data = await response.json();

            this.ads = [...this.ads, ...data.data];

            this.nextPageUrl = data.links.next;
        },
        loadMore() {
            if (this.nextPageUrl) {
                this.page += 1;
                this.fetchAds();
            }
        },
    },
    mounted() {
        this.fetchAds();
    },
};
</script>

<style scoped>
.ad-title-link
{
    text-decoration: none;
}
.ads-list {
    padding: 2rem;
    max-width: 1000px;
    margin: auto;
    background-color: #f9f9f9;
    border-radius: 8px;
}

.title {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 1.5rem;
    color: #333;
}

.ad-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.ad-image-container {
    width: 100%;
    overflow: hidden;
    border-radius: 8px;
    max-height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1rem;
}

.ad-image {
    width: 100%;
    height: auto;
    object-fit: cover;
}

.ad-title {
    font-size: 1.25rem;
    margin: 0.5rem 0;
    color: #222;
    text-align: center;
}
.ad-title:hover{
    color: #0a53be;
    transition: .3s;
}
.ad-price {
    font-size: 1.125rem;
    color: #007bff;
    font-weight: bold;
}

.load-more-button {
    display: block;
    width: 100%;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 0.75rem;
    cursor: pointer;
    border-radius: 4px;
    font-size: 1rem;
    transition: background-color 0.3s;
}

.load-more-button:hover {
    background-color: #0056b3;
}
</style>
