# Sun & String Marketplace — Test Cases

## TC-01 — User Login
**GIVEN** I am not logged in and visit `/login`
**WHEN** I sign in with a valid Google account
**THEN** I am redirected to `/products` and my avatar appears in the navigation bar

## TC-02 — Unauthenticated Redirect
**GIVEN** I am not logged in
**WHEN** I navigate directly to `/products`
**THEN** I am redirected to `/login?returnTo=/products`

## TC-03 — Return to Intended Page After Login
**GIVEN** I tried to visit `/products` while logged out
**WHEN** I complete login
**THEN** I land on `/products`, not just the home page

## TC-04 — Home Page Hero CTA
**GIVEN** I am on the home page `/`
**WHEN** I click "Browse Products"
**THEN** I am taken to `/products` (or `/login` if unauthenticated)

## TC-05 — Trending Products on Home Page
**GIVEN** I am on the home page
**WHEN** the page loads
**THEN** the top 5 trending products across all companies are displayed with name, company, and price

## TC-06 — Products Page Lists All Vendors
**GIVEN** I am logged in and on `/products`
**WHEN** the page finishes loading
**THEN** products from all enabled companies (including Skyline Escapes) appear in the listing

## TC-07 — Filter Products by Company
**GIVEN** I am logged in on `/products`
**WHEN** I filter by "Skyline Escapes"
**THEN** only Skyline Escapes travel packages are shown

## TC-08 — Sort Products by Trending
**GIVEN** I am logged in on `/products`
**WHEN** I sort by "Trending"
**THEN** products are ordered from most-visited to least-visited

## TC-09 — Sort Products by Top Rated
**GIVEN** I am logged in on `/products`
**WHEN** I sort by "Top Rated"
**THEN** products are ordered by descending average rating

## TC-10 — Product Detail Page
**GIVEN** I am logged in and on `/products`
**WHEN** I click a product (e.g., "Europe Tour")
**THEN** the detail page shows the correct name, price, description, image, and rating

## TC-11 — Visit Tracking
**GIVEN** I am logged in
**WHEN** I visit a product detail page
**THEN** that visit is counted and the product moves up in the "Trending" sort order

## TC-12 — Submit a Review
**GIVEN** I am logged in and on a product detail page
**WHEN** I submit a 5-star rating and a written comment
**THEN** the review appears on the page and the average rating updates

## TC-13 — Top 5 Products Per Company
**GIVEN** I am logged in on `/products`
**WHEN** I filter by a specific company and sort by "Top Rated"
**THEN** the top 5 highest-rated products for that company are shown first

## TC-14 — Top 5 Products Marketplace-Wide
**GIVEN** I am logged in on `/products`
**WHEN** I sort by "Top Rated" with no company filter
**THEN** the top 5 highest-rated products across all companies appear at the top

## TC-15 — Logout
**GIVEN** I am logged in
**WHEN** I click my avatar and select "Logout"
**THEN** my session is cleared and I am redirected to the home page as a guest
