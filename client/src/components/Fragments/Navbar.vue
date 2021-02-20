<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container container-fluid">
            <a class="navbar-brand">
                <router-link class="text-decoration-none text-light" :to="{ name: 'home' }">
                    {{ title }}
                </router-link>
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page">
                            <router-link
                                :to="{ name: 'board' }"
                                class="text-decoration-none text-light"
                            >
                                Boards
                            </router-link>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            <router-link
                                :to="{ name: 'stash' }"
                                class="text-decoration-none text-light"
                            >
                                Stash
                            </router-link>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            <router-link
                                :to="{ name: 'about' }"
                                class="text-decoration-none text-light"
                            >
                                About
                            </router-link>
                        </a>
                    </li>
                </ul>
                <form class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <Profile :name="'gio'" />
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </nav>

    <!-- Logout verification modal -->
    <div
        class="modal fade"
        id="staticBackdrop"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center border-0">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Are you sure you want to log out
                    </h5>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary p-0" data-bs-dismiss="modal">
                        <Logout text="Yes" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Profile from '@/components/Fragments/Profile';
import Logout from '@/components/Fragments/Logout';
export default {
    components: {
        Logout,
        Profile
    },
    setup() {
        const title = 'Shea';

        return { title };
    }
};
</script>
