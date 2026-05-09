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

## TC-16 — Search Products by Keyword
**GIVEN** I am logged in and on `/products`
**WHEN** I type a keyword (e.g., "compound") in the search bar and click the search button
**THEN** only products whose name, description, price, or company match the keyword are displayed

## TC-17 — Search with No Results
**GIVEN** I am logged in and on `/products`
**WHEN** I search for a keyword that matches no products (e.g., "zzznomatch")
**THEN** a "No products found" message is displayed and no cards are rendered

## TC-18 — Product Detail Breadcrumb Navigation
**GIVEN** I am logged in and on a product detail page
**WHEN** I click "Products" in the breadcrumb at the top of the page
**THEN** I am taken back to `/products`

## TC-19 — Review Form Hidden After Submission
**GIVEN** I am logged in and have already submitted a review for a product
**WHEN** I revisit that product's detail page
**THEN** the review form is not shown and my existing review appears as "Your Review"

## TC-20 — Non-Existent Product Returns 404
**GIVEN** I am logged in
**WHEN** I navigate to a product detail page with an invalid or non-existent product ID (e.g., `/products/000000`)
**THEN** the server responds with a 404 status and no product content is rendered
