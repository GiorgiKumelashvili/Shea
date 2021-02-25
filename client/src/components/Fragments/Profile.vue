<template>
    <div class="dropdown">
        <button
            type="button"
            class="btn btn-danger rounded-circle"
            id="dropdownMenuOffset"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            data-bs-offset="30,20"
        >
            {{ name[0].toUpperCase() }}
        </button>

        <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="dropdownMenuOffset">
            <li v-for="linkObj in links" :key="linkObj.name">
                <router-link tag="a" class="dropdown-item" :to="linkObj.link">
                    {{ linkObj.name }}
                </router-link>
            </li>
            <li>
                <a
                    class="dropdown-item"
                    href="#"
                    data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"
                >
                    <p class="p-0 m-0">Logout</p>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            default: 'Gio'
        }
    },

    setup() {
        const links = [
            {
                name: 'Archive',
                link: ''
            },
            {
                name: 'Settings',
                link: ''
            },
            {
                name: 'Profile',
                link: ''
            }
        ];

        return { links };
    }
};
</script>
