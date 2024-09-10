<template>
    <div class="create-ad">
        <h1>Create Advertisement</h1>
        <form @submit.prevent="createAd">
            <div class="form-group">
                <label for="title">Title:</label>
                <input v-model="ad.title" id="title" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea v-model="ad.description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input v-model="ad.price" id="price" type="number" step="0.01" class="form-control" />
            </div>
            <div class="form-group">
                <label for="images">Image URLs (comma-separated):</label>
                <input v-model="ad.images" id="images" type="text" class="form-control" placeholder="http://example.com/image1.jpg, http://example.com/image2.jpg" />
            </div>
            <button @click="goBack" class="back-button">Back</button>
            <button type="submit" class="submit-button">Create Ad</button>

            <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ad: {
                title: '',
                description: '',
                price: '',
                images: '',
            },
            errorMessage: '',
        };
    },
    methods: {
        async createAd() {

            const imagesArray = this.ad.images.split(',').map(url => url.trim());

            try {
                const response = await fetch('/api/adverts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ...this.ad,
                        images: imagesArray,
                    }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    this.errorMessage = errorData.message || 'An error occurred.';
                } else {

                    this.ad = { title: '', description: '', price: '', images: '' };
                    this.errorMessage = '';
                    alert('Advert created successfully!');
                }
            } catch (error) {
                this.errorMessage = 'Network error. Please try again.';
            }
        },
        goBack() {
            this.$router.back();
        },
    },
};
</script>

<style scoped>
.create-ad {
    padding: 1rem;
    max-width: 600px;
    margin: auto;
}

.form-group {
    margin-bottom: 1rem;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 0.25rem;
}

.submit-button {
    margin-left: 25px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    border-radius: 0.25rem;
}

.submit-button:hover {
    background-color: #0056b3;
}

.error-message {
    color: red;
    margin-top: 1rem;
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
