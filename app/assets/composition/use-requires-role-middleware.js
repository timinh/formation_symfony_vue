import { jwtDecode } from 'jwt-decode'

export function useRequiresRoleMiddleware(router) {
    router.beforeEach((to, from, next) => {
        console.log(`Navigating to route: ${to.name}`);
        console.log(to.meta)
        if(to.meta && to.meta.requiresRole) {
            const decodedToken = jwtDecode(user_token)
            console.log(decodedToken)
        } else {
            console.log(`Access granted to route ${to.name}`);
        }
        next()
    })
}