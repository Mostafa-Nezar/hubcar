import './bootstrap';
import Swiper from 'swiper/bundle';
import TomSelect from 'tom-select';

window.Swiper = Swiper;
window.TomSelect = TomSelect;

window.countdown = (expiresAt) => {
    return {
        expiresAt: expiresAt,
        time: '',
        init() {
            this.update();
            setInterval(() => this.update(), 1000);
        },
        update() {
            const end = new Date(this.expiresAt).getTime();
            const now = new Date().getTime();
            const distance = end - now;

            if (distance < 0) {
                this.time = "منتهي";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            this.time = `${days}ي ${hours}س ${minutes}د ${seconds}ث`;
        }
    };
};
