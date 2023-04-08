<template>
    <div class="emoji_picker">
        <div class="picker_container">
            <div class="category" v-for="category in categories" :key="`category_${category}`">
                <span>{{ category }}</span>
                <div class="emojis_container">
                    <button @click="handleEmojiClick($event, emoji)" v-for="(emoji, index) in category_emojis(category)" :key="`emoji_${index}`">
                        {{ emoji }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import data from '../../assets/imojis/emojis-data.json';
export default{
    name:"Emoji",

	computed:
	{
		categories()
		{
			return Object.keys(data);
		},

		category_emojis: () => (category) =>
		{
			return Object.values(data[category]);
		}
	},

	methods:
	{
		handleEmojiClick(e, emoji)
		{
			e.preventDefault();
			this.$emit('emoji_click', emoji);
		}
	}
}
</script>

<style scoped>
.emoji_picker {
	position: relative;
	display: flex;
	flex-direction: column;
	width: 20rem;
	height: 20rem;
	max-width: 100%;
}

.emoji_picker{
	box-shadow: 0 0 5px 1px rgba(0, 0, 0, .0975);
}

.emoji_picker,
.picker_container{
	/*border-radius: 0.5rem;*/
	background: white;
}

.picker_container{
	position: relative;
	padding: 1rem;
	overflow: auto;
	z-index: 1;
}

.category{
	display: flex;
	flex-direction: column;
	margin-bottom: 1rem;
	color: rgb(169, 169, 169);
}

.emojis_container{
	display: flex;
	flex-wrap: wrap;
}

.category button{
	margin: 0.5rem;
	margin-left: 0;
	background: inherit;
	border: none;
	font-size: 1.75rem;
	padding: 0;
}
</style>
