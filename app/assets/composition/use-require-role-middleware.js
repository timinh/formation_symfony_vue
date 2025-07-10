import { jwtDecode } from "jwt-decode"

export function useRequireRoleMiddleware(router) {
    router.beforeEach((to, from, next) => {
        const decodedToken = jwtDecode(user_token)
        if(to.meta && to.meta.roles) {
            const {roles: userRoles} = decodedToken;
            if (!userRoles.includes(...to.meta.roles)) {
                next({ path: 'unauthorized' })
            }
        }
        next()
    })
}