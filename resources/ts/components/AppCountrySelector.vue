<template>
    <div class="relative min-w-96">
        <div
            class="flex w-full cursor-pointer justify-between gap-8 border px-4"
            @click="toggleList"
        >
            <span v-html="getCountryInstance(selectedCountry).flag" />
            <span
                class="truncate"
                v-html="getCountryInstance(selectedCountry).name"
            />
        </div>

        <div
            class="bottom right absolute flex h-96 w-full flex-col gap-1 overflow-auto border z-50 bg-white"
            v-if="showCountryList"
        >
            <input
                ref="filterCountryQueryRef"
                class="w-full border px-2 py-1"
                type="text"
                placeholder="Search country..."
                v-model="filterCountryQuery"
                @keydown="handleKeydown"
            />
            <div
                class="flex w-full cursor-pointer justify-between gap-8 px-4 hover:bg-gray-100"
                :class="{ 'bg-blue-100': index === highlightedIndex }"
                v-for="(country, index) in filteredCountryList"
                :value="country.code"
                :key="index"
                :ref="(el) => setCountryRef(el, index)"
                @click="selectCountry(country.name)"
            >
                <span v-html="country.flag" />
                <span class="truncate" v-html="country.name" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import CountryList from 'country-list-with-dial-code-and-flag';
import { computed, nextTick, ref } from 'vue';

const selectedCountry = defineModel<string>({ default: '' }); // model thats manipulated and sent to parent
const showCountryList = ref<boolean>(false); // toggles the list

/*
 ** filter logic: when filterCountryQuery is manipulated (the input=text), it will filter
 ** the CountryList.getAll() array to return include matches or the full list, depending on input
 */
const filterCountryQuery = ref<string>('');
const filterCountryQueryRef = ref<HTMLInputElement | null>(null); // used to conditionally focus the search box
const filteredCountryList = computed(() => {
    if (filterCountryQuery.value.length > 0) {
        return CountryList.getAll().filter((country) =>
            country.name
                .toLowerCase()
                .includes(filterCountryQuery.value.toLowerCase()),
        );
    }
    return CountryList.getAll();
});

/*
 ** handles keyboard inputs for intuitive browsing (arrow up/down and enter/esc)
 */
const highlightedIndex = ref<number>(0); // the current item that is indexed (used primarily with keyboard shortcuts)
const handleKeydown = (e: KeyboardEvent) => {
    const maxIndex = filteredCountryList.value.length - 1;

    switch (e.key) {
        case 'ArrowDown': {
            e.preventDefault();
            highlightedIndex.value = Math.min(
                highlightedIndex.value + 1,
                maxIndex,
            );
            scrollToHighlighted();
            break;
        }
        case 'ArrowUp': {
            e.preventDefault();
            highlightedIndex.value = Math.max(highlightedIndex.value - 1, 0);
            scrollToHighlighted();
            break;
        }
        case 'Enter': {
            e.preventDefault();
            if (filteredCountryList.value[highlightedIndex.value]) {
                selectCountry(
                    filteredCountryList.value[highlightedIndex.value].name,
                );
            }
            break;
        }
        case 'Escape': {
            showCountryList.value = false;
            filterCountryQuery.value = '';
            highlightedIndex.value = 0;
            break;
        }
        default: {
            highlightedIndex.value = 0; // reset highlight when typing
            break;
        }
    }
};

/*
 ** method that will toggle the list, and if opened, will reset the highlighted
 ** index to 0(default) and focus the search bar by default
 */
const toggleList = () => {
    showCountryList.value = !showCountryList.value;
    if (showCountryList.value) {
        highlightedIndex.value = 0;
        nextTick(() => filterCountryQueryRef.value?.focus());
    }
};

/*
 ** method that will properly update the model and clean up UX related variables
 ** closes the list, resets filter query and resets highlight index
 */
const selectCountry = (countryName: string) => {
    selectedCountry.value = countryName;
    showCountryList.value = false;
    filterCountryQuery.value = '';
    highlightedIndex.value = 0;
};

/*
 ** in order to add auto scroll / highlighting whne using keys (up/down/enter) to browse
 ** the list, we map every country to a list which is triggered through scrollToHighlighted
 */
const countryRefs = ref<(HTMLElement | null)[]>([]);
const setCountryRef = (el: any, index: number) => {
    if (el) {
        countryRefs.value[index] = el;
    }
};

const scrollToHighlighted = () => {
    nextTick(() => {
        const highlightedElement = countryRefs.value[highlightedIndex.value];
        if (highlightedElement) {
            highlightedElement.scrollIntoView({
                block: 'nearest',
                behavior: 'smooth',
            });
        }
    });
};

/*
 ** returns the array of a country returned by a keyword: we only ever call this using the
 ** full country name, so it is safe to return index 0 since the package handles empty inputs gracefully
 */
const getCountryInstance = (keyword: string) =>
    CountryList.findByKeyword(keyword)[0];
</script>
