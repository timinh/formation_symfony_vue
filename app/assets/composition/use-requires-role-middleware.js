export function useRequiresRoleMiddleware(router) {
    router.beforeEach((to, from, next) => {
        if(to.meta && to.meta.requiresRole && !to.meta.requiresRole.includes('ROLE_ADMIN')) {
            console.warn(`Access denied to route ${to.name}. Requires role: ${to.meta.requiresRole}`);
            next('/unauthorized')
        } else {
            console.log(`Access granted to route ${to.name}`);
        }
        next()
    })
}