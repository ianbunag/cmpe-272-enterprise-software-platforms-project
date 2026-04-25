# Checklist

## Pages/Functionalities

- [ ] Login / Create user (FirebaseUI)
- [ ] Marketplace
  - [ ] Filters
    - [ ] Most visited (Visit Service)
    - [ ] Top-rated (Rating Service)
    - [ ] Company (Company Service)
  - [ ] Sort
    - [ ] Most visited (Visit Service)
    - [ ] Top-rated (Rating Service)
    - [ ] Company (Company Service)
  - [ ] Products/Services listing (Company Service)
    - [ ] Track user visits (Heap Analytics)
    - [ ] Visit website (Company Service)
    - [ ] Products/Services cache (Cache Service)
- [ ] Product/Service page (Company Service)
  - [ ] Track user visits (Visit Service)
  - [ ] Add review and rating for products/services (Rating Service)
  - [ ] Product/Service cache (Cache Service)


## Planning notes
- Authentication is integrated in the Marketplace only. Companies can later integrate in their own apps by using the same FirebaseUI configuration.
- Caching is in-memory for now, but can be extended to use a more robust solution like Redis in the future.
  - Website data are fetched on-demand for now, but can be pre-fetched or updated through webhooks in the future.

## Extra features
- Website analytics (Heap Analytics)
- Sorting functionality in the marketplace
- Caching of website data to improve performance
- Social login options (Google, Facebook, etc.) through FirebaseUI
