<template>
  <tags-input element-id="tags"
    v-model="selectedTags"
    :existing-tags="{ 
        'web-development': 'Web Development',
        'php': 'PHP',
        'javascript': 'JavaScript',
    }"
    :typeahead="true"></tags-input>
</template>
