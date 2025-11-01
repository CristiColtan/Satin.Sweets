export function extractApiError(
    error,
    {
        defaultMessage = 'A apărut o eroare. Încearcă din nou.',
        joinFieldErrors = true, // dacă vrei toate mesajele concatenate
        delimiter = '\n', // separator pentru concatenare
    } = {},
) {
    // Status HTTP (dacă există)
    const status = error?.response?.status ?? null

    // Răspuns JSON din backend (Laravel)
    const data = error?.response?.data ?? null
    const backendMessage = data?.message || null
    const fieldErrors =
        data?.errors && typeof data.errors === 'object' ? data.errors : null

    // Caz 422: validare
    if (status === 422) {
        if (fieldErrors) {
            if (joinFieldErrors) {
                // concatenăm toate mesajele într-un singur string
                const all = Object.values(fieldErrors).flat().filter(Boolean)
                return {
                    status,
                    message: all.length
                        ? all.join(delimiter)
                        : backendMessage || defaultMessage,
                    fieldErrors,
                }
            } else {
                // doar primul mesaj (stilul tău inițial)
                const firstKey = Object.keys(fieldErrors)[0]
                const firstMsg = fieldErrors[firstKey]?.[0]
                return {
                    status,
                    message: firstMsg || backendMessage || defaultMessage,
                    fieldErrors,
                }
            }
        }
        // 422 dar fără `errors` structurate
        return {
            status,
            message: backendMessage || defaultMessage,
            fieldErrors: null,
        }
    }

    // Alte coduri HTTP cunoscute (poți extinde după nevoie)
    if (status === 401) {
        return { status, message: 'Nu ești autentificat.', fieldErrors: null }
    }
    if (status === 403) {
        return {
            status,
            message: 'Nu ai permisiune pentru această acțiune.',
            fieldErrors: null,
        }
    }
    if (status === 404) {
        return {
            status,
            message: 'Resursa nu a fost găsită.',
            fieldErrors: null,
        }
    }
    if (status >= 500 && status < 600) {
        return {
            status,
            message: 'Eroare de server. Încearcă mai târziu.',
            fieldErrors: null,
        }
    }

    // Fallback: fără response sau fără status (ex: rețea picată)
    if (error?.message && !error?.response) {
        // erori de rețea/timeouts etc.
        return {
            status: null,
            message: 'Probleme de rețea. Verifică conexiunea.',
            fieldErrors: null,
        }
    }

    // Ultimul fallback
    return {
        status,
        message: backendMessage || defaultMessage,
        fieldErrors: null,
    }
}
