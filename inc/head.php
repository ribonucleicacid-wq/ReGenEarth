<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>ReGenEarth</title>
<link rel="icon" type="image/png" href="uploads/logo.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<!-- <link rel="stylesheet" href="assets/css/animate.css" /> -->
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />

<style>
    .anim-wrapper {
        display: flex;
        align-items: center;
        color: #fff;
        padding: 0.5rem 0;
    }

    .anim-re-text {
        font-size: 4rem;
        font-weight: 600;
        margin-right: 0;
    }

    .anim-content {
        font: 4rem "Arial", sans-serif;
        font-weight: 600;
        overflow: hidden;
        position: relative;
    }

    .anim-content ol {
        list-style: none;
        padding: 0;
        margin: 0;
        height: 3.8rem;
        line-height: 5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }

    .anim-content ol li {
        animation: anim-slide-up 12s infinite;
        height: 3.8rem;
        line-height: 3.8rem;
    }

    @keyframes anim-slide-up {

        0%,
        10% {
            transform: translateY(0%);
        }

        15%,
        25% {
            transform: translateY(-100%);
        }

        30%,
        40% {
            transform: translateY(-200%);
        }

        45%,
        55% {
            transform: translateY(-300%);
        }

        60%,
        70% {
            transform: translateY(-400%);
        }
    }

    .anim-typewriter {
        font-size: 2.5rem;
        margin-top: 1rem;
        color: #fff;
    }

    .anim-wrapper-2 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        margin-top: 1rem;
        position: absolute;
    }

    .anim-button button {
        padding: .8rem 1.6rem;
        background-color: crimson;
        color: #fff;
        border: none;
        border-radius: 2rem;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .anim-button {
        padding-left: 400px;
        padding-top: 150px;
        position: absolute;
    }

    .anim-bg-section {
        min-height: 100vh;
        background: url("assets/images/cover.png") center / cover;
        background-blend-mode: multiply;
        background-attachment: fixed;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        align-content: center;
        flex-direction: column;
        padding bottom: 2rem;
        padding-left: 6rem;
    }
</style>