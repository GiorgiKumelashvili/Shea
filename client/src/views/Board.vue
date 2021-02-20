<template>
    <h1>Board</h1>
    <div class="bg-light" style="width:500px">
        <div class="d-flex flex-column">
            <label for="exampleFormName" class="form-label ps-1">
                Name
            </label>
            <input
                type="text"
                id="exampleFormName"
                class="form-control"
                placeholder="Name"
                aria-label="Name"
                aria-describedby="basic-addon1"
            />
        </div>

        <div class="d-flex flex-column">
            <label for="exampleFormUrl" class="form-label ps-1">
                Url
            </label>
            <div class="input-group" id="exampleFormUrl">
                <input
                    type="text"
                    class="form-control"
                    id="basic-url"
                    placeholder="https://example.com"
                    aria-describedby="basic-addon3"
                    aria-label="basic-addon3"
                />
                <span class="input-group-text p-0" id="basic-addon1">
                    <img :src="require('@/assets/svgs/bi-link.svg')" class="pointer p-2" />
                </span>
            </div>
        </div>

        <div class="d-flex flex-column">
            <label for="exampleFormTextarea" class="form-label ps-1">
                Description
            </label>
            <textarea class="form-control" id="exampleFormTextarea" rows="4"></textarea>
        </div>
    </div>
</template>
