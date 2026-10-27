// INICIALIZACIÓN
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    flushPendingToast();
    if (currentUser) {
        showAppScreen();
    } else {
        showAuthScreen();
    }
});
